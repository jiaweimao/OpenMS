# --------------------------------------------------------------------------
#                   OpenMS -- Open-Source Mass Spectrometry
# --------------------------------------------------------------------------
# Copyright The OpenMS Team -- Eberhard Karls University Tuebingen,
# ETH Zurich, and Freie Universitaet Berlin 2002-2012.
#
# This software is released under a three-clause BSD license:
#  * Redistributions of source code must retain the above copyright
#    notice, this list of conditions and the following disclaimer.
#  * Redistributions in binary form must reproduce the above copyright
#    notice, this list of conditions and the following disclaimer in the
#    documentation and/or other materials provided with the distribution.
#  * Neither the name of any author or any participating institution
#    may be used to endorse or promote products derived from this software
#    without specific prior written permission.
# For a full list of authors, refer to the file AUTHORS.
# --------------------------------------------------------------------------
# THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS"
# AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE
# IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE
# ARE DISCLAIMED. IN NO EVENT SHALL ANY OF THE AUTHORS OR THE CONTRIBUTING
# INSTITUTIONS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL,
# EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED TO,
# PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE, DATA, OR PROFITS;
# OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY THEORY OF LIABILITY,
# WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR
# OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF
# ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
#
# --------------------------------------------------------------------------
# $Maintainer: Stephan Aiche, Chris Bielow $
# $Authors: Chris Bielow, Stephan Aiche $
# --------------------------------------------------------------------------

#------------------------------------------------------------------------------
# This cmake file only handles the customization of internal path variables
# where the build system expects to find external libraries. Note that the
# actual libraries are found in the CMake files of the individual componenents.
#------------------------------------------------------------------------------

#------------------------------------------------------------------------------
# emit warning if CMAKE_FIND_ROOT_PATH is used instead of CMAKE_PREFIX_PATH
if(NOT "${CMAKE_FIND_ROOT_PATH}" STREQUAL "" AND "${CMAKE_PREFIX_PATH}" STREQUAL "")
  set(CMAKE_PREFIX_PATH "${CMAKE_FIND_ROOT_PATH}")
  message(STATUS "Please use CMAKE_PREFIX_PATH instead of CMAKE_FIND_ROOT_PATH ")
endif()

#------------------------------------------------------------------------------
# add contrib location of source package <source>/contrib
list(APPEND CMAKE_PREFIX_PATH ${OPENMS_HOST_DIRECTORY}/contrib/)

#------------------------------------------------------------------------------
# Ensure Qt includes it's libs as SYSTEM
set(QT_INCLUDE_DIRS_NO_SYSTEM Off)
